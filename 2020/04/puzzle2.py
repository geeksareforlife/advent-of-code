import re

def isValid(passport):
	actualValid = ['byr', 'cid', 'ecl', 'eyr', 'hcl', 'hgt', 'iyr', 'pid']
	missingCid = ['byr', 'ecl', 'eyr', 'hcl', 'hgt', 'iyr', 'pid']

	check = sorted(passport)

	if check == actualValid:
		return validateFields(passport)
	elif check == missingCid:
		return validateFields(passport)
	else:
		return False

def validateFields(passport):
	# return false as soon as we find an issue
	
	if not checkYear(passport['byr'], 1920, 2002):
		return False

	if not checkYear(passport['iyr'], 2010, 2020):
		return False

	if not checkYear(passport['eyr'], 2020, 2030):
		return False

	if not checkHeight(passport['hgt']):
		return False

	if not checkHexColor(passport['hcl']):
		return False

	if not checkEyeColor(passport['ecl']):
		return False

	if not checkID(passport['pid']):
		return False

	# must be valid!
	return True

def checkYear(year, minYear, maxYear):
	if len(year) != 4:
		return False

	year = int(year)

	if year < minYear or year > maxYear:
		return False
	else:
		return True

def checkHeight(height):
	match = re.search('(\d*)(in|cm)', height)

	if match == None:
		return False
	else:
		height = int(match[1])

		if match[2] == "cm":
			if height >= 150 and height <= 193:
				return True
			else:
				return False
		elif match[2] == "in":
			if height >= 59 and height <= 76:
				return True
			else:
				return False
		else:
			return False

def checkHexColor(color):
	match = re.search('#[0-9a-f]{6}', color)

	if match == None:
		return False
	else:
		return True

def checkEyeColor(color):
	eyeColors = ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']

	if color in eyeColors:
		return True
	else:
		return False

	return True

def checkID(id):
	match = re.search('^\d{9}$', id)

	if match == None:
		return False
	else:
		return True

def storeFields(passport, line):
	fields = line.split(" ")
	for field in fields:
		(key, value) = field.split(":")
		passport[key] = value

	return passport

with open('input') as input:
	lines = list(input)

lines = [x.strip() for x in lines]

passport = {}
validPassports = 0

for line in lines:
	if line == "":
		# end of passport, check for validailty and reset
		if isValid(passport):
			validPassports += 1
		passport = {}
	else:
		passport = storeFields(passport, line)


print("There are " + str(validPassports) + " valid passports")