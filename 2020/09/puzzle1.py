import itertools

def validate(number, preamble):
	valid = False
	for pair in itertools.combinations(preamble, 2):
		if (pair[0] + pair[1]) == number:
			valid = True
			break

	return valid


with open('input') as input:
	numbers = list(input)

numbers = [int(x) for x in numbers]

preamble = 25
end = len(numbers)

for i in range(preamble, end):
	if not validate(numbers[i], numbers[i-preamble:i]):
		break

print("The first number that is not valid is " + str(numbers[i]))