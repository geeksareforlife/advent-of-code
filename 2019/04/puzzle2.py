import re

def isPasswordValid(testPassword):
	match = re.findall('((\d)\\2+)', str(testPassword))

	if match == None:
		return False
	else:
		double = False
		for possible in match:
			if len(possible[0]) == 2:
				double = True
		if not double:
			return False

	curr = 0
	for num in str(testPassword):
		num = int(num)
		if num < curr:
			return False
		else:
			curr = num

	return True

rangeStart = 138241
rangeEnd = 674034

validPasswords = []

for testPassword in range(rangeStart, rangeEnd+1):
	if isPasswordValid(testPassword):
		validPasswords.append(testPassword)


print("There are " + str(len(validPasswords)) + " valid passwords")