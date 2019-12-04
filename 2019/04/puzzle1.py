import re

def isPasswordValid(testPassword):
	match = re.search('(\d)\\1', str(testPassword))

	if match == None:
		return False

	curr = 0
	for num in str(testPassword):
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