def processRule(rule):
	[number, letter] = rule.split(' ')
	[minNum, maxNum] = [int(x) for x in number.split('-')]

	return [minNum, maxNum, letter]

def countInstances(text, letter):
	if letter not in text:
		return 0
	else:
		return text.count(letter)

with open('input') as input:
	lines = list(input)

lines = [x.strip().split(': ') for x in lines]

validCount = 0

for [rule, password] in lines:
	[minNum, maxNum, letter] = processRule(rule)

	instances = countInstances(password, letter)

	if instances >= minNum and instances <= maxNum:
		validCount += 1


print("There are " + str(validCount) + " valid passwords")
	

