from collections import deque

class Intcode:
	_programme = ""
	_loaded = False
	_pointer = 0
	_running = False
	_halted = False
	_errorMessage = None

	_waitingForInput = False

	_input = deque([])
	_output = deque([])
	_inputMode = "console"
	_outputMode = "immediate"

	def loadProgramme(self, programme):
		self._loaded = True
		self._input = deque([])
		self._output = deque([])
		self._programme = [int(i) for i in programme.strip().split(",")]

	def setNoun(self, value):
		self._storeValueAtAddress(value, 1)

	def setVerb(self, value):
		self._storeValueAtAddress(value, 2)

	def getAddressZero(self):
		return self._getValueFromAddress(0)

	def setInputMode(self, mode):
		allowedModes = ["console", "internal"]
		if mode in allowedModes:
			self._inputMode = mode

	def addInput(self, input):
		self._input.append(input)
		if self._waitingForInput:
			self._waitingForInput = False
			self._continue()

	def setOutputMode(self, mode):
		allowedModes = ["immediate", "saved"]
		if mode in allowedModes:
			self._outputMode = mode

	def getOutput(self):
		if len(self._output) > 0:
			return self._output.popleft()
		else:
			return False

	def hasHalted(self):
		return self._halted

	def run(self):
		self._pointer = 0
		self._errorMessage = None
		self._running = True
		self._halted = False

		return self._runProgramme()

	def _runProgramme(self):
		while self._running and self._pointer < len(self._programme):
			instruction = self._getValueFromAddress(self._pointer)

			opcode, parameterString = self._parseInstruction(instruction)

			if opcode:
				self._processOperation(opcode, parameterString)
			else:
				self._running = False

		if self._halted:
			return True
		else:
			return False

	def _continue(self):
		self._running = True

		return self._runProgramme()

	def _addressExists(self, address):
		if address >= len(self._programme):
			return False
		else:
			return True

	def _getValueFromAddress(self, address):
		if self._addressExists(address):
			return self._programme[address]
		else:
			# stop the programme
			raise Exception("Attempted to read value from non-existent address: " + str(address))

	def _storeValueAtAddress(self, value, address):
		if self._addressExists(address):
			self._programme[address] = value
		else:
			raise Exception("Attempted to store value into non-existent address: " + str(address))

	def _parseInstruction(self, instruction):
		if instruction < 10:
			return (instruction, "")
		else:
			instruction = str(instruction)

			opcode = int(instruction[-2: len(instruction)])
			parameterString = instruction[0: len(instruction) - 2]

			return (opcode, parameterString)

	def _getAddresses(self, num):
		addresses = []
		for i in range(1, num + 1):
			addresses.append(self._getValueFromAddress(self._pointer + i))

		if len(addresses) > 1:
			return tuple(addresses)
		else:
			return addresses[0]

	def _getValues(self, addresses, parameters):
		values = []
		for i in range(len(addresses)):
			address = addresses[i]

			if parameters[i] == 0:
				# position mode
				values.append(self._getValueFromAddress(address))
			elif parameters[i] == 1:
				# immediate mode
				values.append(address)

		if len(values) > 1:
			return tuple(values)
		else:
			return values[0]

	def _outputMessage(self, message):
		print("**" + message.upper() + "**")

	def _incrementPointer(self, step = 1):
		self._pointer = self._pointer + step

	def _parseParameters(self, parameterString, count):
		parameters = list(parameterString.rjust(count, '0'))
		parameters = [int(i) for i in parameters]
		parameters.reverse()
		return parameters

	def _processOperation(self, opcode, parameterString):
		if opcode == 99:
			# HALT
			# 0 parameters
			if self._outputMode == "immediate":
				self._outputMessage("Halt")
			self._running = False
			self._halted = True
			self._incrementPointer()
		elif opcode == 1 or opcode == 2 or opcode == 7 or opcode == 8:
			# ADDITION / MULTIPLY / LESS THAN / EQUALS
			# 3 parameters - input A, input B, output address
			parameters = self._parseParameters(parameterString, 3)
			inputA, inputB, outputAddress = self._getAddresses(3)
			inputA, inputB = self._getValues([inputA, inputB], parameters)
			if opcode == 1:
				value = inputA + inputB
			elif opcode == 2:
				value = inputA * inputB
			elif opcode == 7:
				if inputA < inputB:
					value = 1
				else:
					value = 0
			elif opcode == 8:
				if inputA == inputB:
					value = 1
				else:
					value = 0
			self._storeValueAtAddress(value, outputAddress)
			self._incrementPointer(4)
		elif opcode == 3:
			# INPUT
			# 1 parameter - output address
			parameters = self._parseParameters(parameterString, 1)
			outputAddress = self._getAddresses(1)
			if self._inputMode == "console":
				value = int(input())
				increment = 2
			elif self._inputMode == "internal":
				if (len(self._input) > 0):
					value = self._input.popleft()
					increment = 2
				else:
					self._waitingForInput = True
					self._running = False
					increment = 0

			if increment > 0:
				self._storeValueAtAddress(value, outputAddress)
				self._incrementPointer(increment)
		elif opcode == 4:
			# OUTPUT
			# 1 parameter - input
			parameters = self._parseParameters(parameterString, 1)
			value = self._getAddresses(1)
			value = self._getValues([value], parameters)
			if self._outputMode == "saved":
				self._output.append(value)
			elif self._outputMode == "immediate":
				self._outputMessage("output: " + str(value))
			self._incrementPointer(2)
		elif opcode == 5 or opcode == 6:
			# JUMP IF TRUE / JUMP IF FALSE
			# 2 parameters - test and pointer value
			parameters = self._parseParameters(parameterString, 2)
			test, pointer = self._getAddresses(2)
			test, pointer = self._getValues([test, pointer], parameters)
			if (opcode == 5 and test > 0) or (opcode == 6 and test == 0):
				self._pointer = pointer
			else:
				self._incrementPointer(3)
