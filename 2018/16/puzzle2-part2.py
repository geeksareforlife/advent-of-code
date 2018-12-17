import operations
import re

opcodes = {9: 'addr', 0: 'muli', 15: 'gtir', 3: 'eqri', 8: 'mulr', 2: 'gtri', 4: 'gtrr', 11: 'bani', 14: 'banr', 13: 'eqrr', 5: 'eqir', 12: 'seti', 7: 'setr', 10: 'bori', 6: 'addi', 1: 'borr'}

def parseInstructions(lines):
	instructions = []

	for line in lines:
		match = re.search('(?P<opcode>\d+) (?P<a>\d) (?P<b>\d) (?P<c>\d)', line.strip())
		if match == None:
			print("Instruction doesn't match: " + line)
			continue
		instructions.append({
			'opcode': int(match['opcode']),
			'a': int(match['a']),
			'b': int(match['b']),
			'c': int(match['c'])
		})

	return instructions



##### START MAIN #####
with open('input.part2') as input:
	instructions = parseInstructions(list(input))

registers = [0, 0, 0, 0]

for instruction in instructions:
	op = opcodes[instruction['opcode']]
	opToCall = getattr(operations, op)
	registers = opToCall(registers, instruction['a'], instruction['b'], instruction['c'])

print(registers)