

inputFile = open('input')
programme = map(int, inputFile.read().strip().split(","))

# restore 1202 alarm
programme[1] = 12
programme[2] = 2

for i in range(0, len(programme), 4):
	opcode = programme[i]
	if opcode == 99:
		break

	inputA = programme[programme[i+1]]
	inputB = programme[programme[i+2]]
	outputPos = programme[i+3]
	#print(programme)
	
	if opcode == 1:
		# addition
		programme[outputPos] = inputA + inputB
	elif opcode == 2:
		# multiply
		programme[outputPos] = inputA * inputB
	else:
		print("opcode not recognised")
		print(opcode)

print(programme)
print("Programme complete. Value at position 0 is: " + str(programme[0]))