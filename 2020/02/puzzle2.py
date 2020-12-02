def processRule(rule):
	[number, letter] = rule.split(' ')
	# minus 1 to get 0-index
	[firstPos, secondPos] = [int(x)-1 for x in number.split('-')]

	return [firstPos, secondPos, letter]



with open('input') as input:
	lines = list(input)

lines = [x.strip().split(': ') for x in lines]

validCount = 0

for [rule, password] in lines:
	[firstPos, secondPos, letter] = processRule(rule)

	if password[firstPos] == letter or password[secondPos] == letter:
		if not (password[firstPos] == letter and password[secondPos] == letter):
			validCount += 1
	


print("There are " + str(validCount) + " valid passwords")
	

