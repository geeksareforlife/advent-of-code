with open('input') as input:
	program = list(input)

program = [x.strip().split(" ") for x in program]
program = [(x[0], int(x[1])) for x in program]

current = 0
acc = 0

executed = set()

running = True

while running:
	# add the current instruction to the list, if we can
	# exit before executing the instruction if we have seen this before
	if current not in executed:
		executed.add(current)
	else:
		running = False
		break

	# execute the current instruction
	instruction = program[current]
	if instruction[0] == "nop":
		# no operation!
		current += 1
		continue
	elif instruction[0] == "acc":
		acc = acc + instruction[1]
		current += 1
	elif instruction[0] == "jmp":
		current = current + instruction[1]

print("Just before the infinite loop, the accumulator was at " + str(acc))