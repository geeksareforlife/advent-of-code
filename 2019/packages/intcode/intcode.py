class Intcode:
	_programme = ""
	_loaded = False
	_pointer = 0
	_running = False
	_halted = False
	_errorMessage = None

	def loadProgramme(self, programme):
		self._loaded = True
		self._programme = [int(i) for i in programme.strip().split(",")]

	def setNoun(self, value):
		self._storeValueAtAddress(value, 1)

	def setVerb(self, value):
		self._storeValueAtAddress(value, 2)

	def getAddressZero(self):
		return self._getValueFromAddress(0)

	def run(self):
		self._pointer = 0
		self._errorMessage = None
		self._running = True
		self._halted = False

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

		return tuple(addresses)

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

		return tuple(values)

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
			self._outputMessage("Halt")
			self._running = False
			self._halted = True
			self._incrementPointer()
		elif opcode == 1:
			parameters = self._parseParameters(parameterString, 3)
			inputA, inputB, outputAddress = self._getAddresses(3)
			inputA, inputB = self._getValues([inputA, inputB], parameters)
			self._storeValueAtAddress(inputA + inputB, outputAddress)
			self._incrementPointer(4)
		elif opcode == 2:
			parameters = self._parseParameters(parameterString, 3)
			inputA, inputB, outputAddress = self._getAddresses(3)
			inputA, inputB = self._getValues([inputA, inputB], parameters)
			self._storeValueAtAddress(inputA * inputB, outputAddress)
			self._incrementPointer(4)