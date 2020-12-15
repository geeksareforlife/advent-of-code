import re
import itertools

def applyMask(number):
	inputBinary = list("{0:036b}".format(number))
	outputBinary = ""

	for i in range(len(inputBinary)):
		if mask[i] == '0':
			outputBinary += inputBinary[i]
		else:
			outputBinary += mask[i]

	return outputBinary

def getAddresses(number):
	addresses = []

	outputBinary = list(applyMask(number))

	# where are the Xs?
	indices = [i for i, x in enumerate(outputBinary) if x == "X"]

	looper = itertools.product(['0','1'], repeat=len(indices))

	for replace in looper:
		address = outputBinary.copy()
		for i in range(len(indices)):
			address[indices[i]] = replace[i]
		addresses.append("".join(address))


	return addresses

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
		addresses = getAddresses(int(match[1]))

		for address in addresses:
			memory[address] = int(ins[1])


print("The sum of all memory values is " + str(sum(list(memory.values()))))