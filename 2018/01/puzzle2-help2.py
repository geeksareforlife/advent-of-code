# Changed after looking at other people's solutions!
# itertools seems amazing!

import itertools

def getDuplicateFreq(start, changes):
	freq = start
	freqs = set([freq])

	duplicate = False

	for change in itertools.cycle(changes):
		freq = freq + int(change.strip())
		if freq in freqs:
			return freq
		else:
			freqs.add(freq)


freq = 0

with open('input') as input:
	changes = list(input)

duplicate = getDuplicateFreq(freq, changes)


print("The first duplicated frequency is " + str(duplicate))