def getDuplicateFreq(start, changes):
	freq = start
	freqs = []

	duplicate = False

	while True:
		for change in changes:
			freq = freq + int(change.strip())
			if freq in freqs:
				return freq
			else:
				freqs.append(freq)


freq = 0

with open('input') as input:
	changes = list(input)

duplicate = getDuplicateFreq(freq, changes)


print("The first duplicated frequency is " + str(duplicate))