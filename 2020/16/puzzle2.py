def testRules(rules, value):
	validRules = []
	for rule in rules:
		print(rule + " : " + str(value))
		valid = False
		ranges = rules[rule]

		for thisRange in ranges:
			if value >= thisRange[0] or value <= thisRange[1]:
				valid = True
		if valid:
			validRules.append(rule)

	return validRules

with open('input.validtickets.test') as input:
	tickets = list(input)

tickets = [x.strip().split(",") for x in tickets]
tickets = [[int(i) for i in ticket] for ticket in tickets]

numFields = len(tickets[0])

#myTicket = [71,127,181,179,113,109,79,151,97,107,53,193,73,83,191,101,89,149,103,197]
myTicket = [11,12,13]

with open('input.rules.test') as input:
	inputRules = list(input)

rules = {}
positions = {}

for rule in inputRules:
	rule = rule.strip()
	[field, rule] = rule.split(': ')
	ranges = []
	for thisRange in rule.split(' or '):
		ranges.append(tuple([int(i) for i in thisRange.split('-')]))
	rules[field] = ranges
	positions[field] = set()

# get valid positions
for ticket in tickets:
	for position in range(numFields):
		validRules = testRules(rules, ticket[position])
		for validRule in validRules:
			positions[validRule].add(position)

print(positions)