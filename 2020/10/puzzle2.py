with open('input') as input:
	joltages = list(input)

joltages = [int(x) for x in joltages]
joltages = set(joltages)

paths = {
	0: 1
}

for joltage in joltages:
	paths[joltage] = 0
	for testJoltage in range(joltage-3, joltage):
		if testJoltage == 0 or testJoltage in sorted(paths):
			paths[joltage] += paths[testJoltage]

print("There are " + str(paths[max(joltages)]) + " different paths")