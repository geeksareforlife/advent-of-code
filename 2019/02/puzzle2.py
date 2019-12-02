def runProgramme(programme):
	for i in range(0, len(programme), 4):
		opcode = programme[i]
		if opcode == 99:
			break

		if (i + 3) >= len(programme):
			return -1

		if programme[i+1] >= len(programme) or programme[i+2] >= len(programme):
			return -1

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
			return(-1)

	return programme[0]

def loopPairs(n):
	for i in range(100):
		for j in range(100):
			yield i, j

inputFile = open('input')
orgProgramme = map(int, inputFile.read().strip().split(","))

for i,j in loopPairs(100):
	newProg = list(orgProgramme)
	newProg[1] = i
	newProg[2] = j

	if (runProgramme(newProg) == 19690720):
		print(newProg)
		code = (100 * i) + j
		print(code)

		break