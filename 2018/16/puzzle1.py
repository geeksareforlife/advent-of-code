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

countThreePlus = 0

for sample in samples:
	# try each operation!
	for operation in operations.operations:
		registers = operation(sample['before'], sample['instruction']['a'], sample['instruction']['b'], sample['instruction']['c'])
		if registers == sample['after']:
			sample['behaves'].append(operation.__name__)

	if len(sample['behaves']) >= 3:
		countThreePlus = countThreePlus + 1

print(str(countThreePlus) + " samples behave as three or more opcodes")