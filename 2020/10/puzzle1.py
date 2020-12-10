with open('input') as input:
	joltages = list(input)

joltages = [int(x) for x in joltages]

joltages = sorted(joltages)

numOfNums = len(joltages)

differences = {}
lastJoltage = 0

for i in range(numOfNums):
	diff = joltages[i] - lastJoltage
	differences[diff] = differences.get(diff, 0) + 1

	lastJoltage = joltages[i]

# last diff is always 3
differences[3] = differences.get(3, 0) + 1

print("The number of 1s multiplied by 3s is " + str(differences[1] * differences[3]))