with open('input') as input:
	program = list(input)

program = [x.strip().split(" ") for x in program]
program = [(x[0], int(x[1])) for x in program]

altered = set()

found = False

while not found:
	# try and change each instruction in turn and run the program
	current = 0
	acc = 0
	executed = set()

	# have we changed an instruction this time?
	changed = False

	while True:
		# add the current instruction to the list, if we can
		# exit before executing the instruction if we have seen this before
		if current not in executed:
			executed.add(current)
		else:
			break

		if current >= len(program):
			# normal termination!#
			found = True
			break

		# execute the current instruction
		instruction = program[current]
		if instruction[0] == "nop":
			if not changed and current not in altered:
				# change this to a jmp and try this instruction again
				altered.add(current)
				current = current + instruction[1]
				changed = True
			else:
				# no operation!
				current += 1
				continue
		elif instruction[0] == "acc":
			acc = acc + instruction[1]
			current += 1
		elif instruction[0] == "jmp":
			if not changed and current not in altered:
				# change this to a nop and try this instruction again
				altered.add(current)
				current += 1
				changed = True
				continue
			else:
				current = current + instruction[1]

print(altered)
print("The accumulator was " + str(acc))