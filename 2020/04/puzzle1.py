def isValid(passport):
	actualValid = ['byr', 'cid', 'ecl', 'eyr', 'hcl', 'hgt', 'iyr', 'pid']
	missingCid = ['byr', 'ecl', 'eyr', 'hcl', 'hgt', 'iyr', 'pid']

	check = sorted(passport)

	if check == actualValid:
		return True
	elif check == missingCid:
		return True
	else:
		return False

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