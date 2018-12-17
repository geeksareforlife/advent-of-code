import re
import operations

def parseSamples(lines):
	samples = []

	for i in range(0, len(lines), 4):
		sample = {
			'behaves': []
		}

		match = re.search('Before: \[(?P<registers>[\d,\s]+)\]', lines[i].strip())
		if match == None:
			print("Sample doesn't match: " + lines[i])
			continue
		sample['before'] = list(map(int, match['registers'].split(', ')))

		match = re.search('(?P<opcode>\d+) (?P<a>\d) (?P<b>\d) (?P<c>\d)', lines[i+1].strip())
		if match == None:
			print("Sample doesn't match: " + lines[i+1])
			continue
		sample['instruction'] = {
			'opcode': int(match['opcode']),
			'a': int(match['a']),
			'b': int(match['b']),
			'c': int(match['c'])
		}

		match = re.search('After:  \[(?P<registers>[\d,\s]+)\]', lines[i+2].strip())
		if match == None:
			print("Sample doesn't match: " + lines[i+2])
			continue
		sample['after'] = list(map(int, match['registers'].split(', ')))

		samples.append(sample)

	return samples




##### START MAIN #####
with open('input.part1') as input:
	samples = parseSamples(list(input))

opcodes = {}

for sample in samples:
	# try each operation!
	for operation in operations.operations:
		registers = operation(sample['before'], sample['instruction']['a'], sample['instruction']['b'], sample['instruction']['c'])
		if registers == sample['after']:
			sample['behaves'].append(operation.__name__)

for sample in samples:
	if len(sample['behaves']) == 1:
		opcodes[sample['instruction']['opcode']] = sample['behaves']
	else:
		if sample['instruction']['opcode'] not in opcodes:
			opcodes[sample['instruction']['opcode']] = sample['behaves']
		else:
			for opcode in opcodes[sample['instruction']['opcode']]:
				if opcode not in sample['behaves']:
					opcodes[sample['instruction']['opcode']].remove(opcode)


takenCodes = []

while len(takenCodes) < 15:
	for opcode in opcodes:
		if len(opcodes[opcode]) == 1:
			if opcodes[opcode][0] not in takenCodes:
				takenCodes.append(opcodes[opcode][0])
			continue

		newBehaves = []
		for behave in opcodes[opcode]:
			if behave not in takenCodes:
				newBehaves.append(behave)
		opcodes[opcode] = newBehaves

print(opcodes)
