import re

def applyMask(number):
	inputBinary = list("{0:036b}".format(number))
	outputBinary = ""

	for i in range(len(inputBinary)):
		if mask[i] == 'X':
			outputBinary += inputBinary[i]
		else:
			outputBinary += mask[i]

	return int(outputBinary, 2)

with open('input') as input:
	instructions = list(input)

instructions = [x.strip().split(' = ') for x in instructions]

mask = '0'

memory = {}

for ins in instructions:
	if ins[0] == 'mask':
		mask = list(ins[1])
	else:
		match = re.search('mem\[(\d+)\]', ins[0])
		memory[match[1]] = applyMask(int(ins[1]))

print("The sum of all memory values is " + str(sum(list(memory.values()))))