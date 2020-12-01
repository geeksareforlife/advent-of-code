import itertools

with open('input') as input:
	entries = list(input)

entries = [int(x.strip()) for x in entries]

output = 0

for pair in itertools.combinations(entries, 2):
	if (pair[0] + pair[1]) == 2020:
		output = pair[0] * pair[1]
		break;

print("The answer is " + str(output))