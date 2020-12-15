f = open('input')
numbers = [int(i) for i in f.read().strip().split(",")]

seen = {
	0: []
}
lastNumber = 0

for turn in range(30000000):
	if turn < len(numbers):
		seen[numbers[turn]] = [(turn+1)]
		lastNumber = numbers[turn]
	else:
		if lastNumber not in seen:
			seen[0].append(turn + 1)
			lastNumber = 0
		elif len(seen[lastNumber]) == 1:
			seen[0].append(turn + 1)
			lastNumber = 0
		else:
			timesSeen = len(seen[lastNumber])
			number = seen[lastNumber][timesSeen - 1] - seen[lastNumber][timesSeen - 2]
			if number not in seen:
				seen[number] = []
			seen[number].append(turn + 1)
			lastNumber = number

print("The 2020th number is " + str(lastNumber))