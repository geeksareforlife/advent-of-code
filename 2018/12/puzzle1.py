import re

def parseInput(lines):
	# the first line should be our initial state
	pots = ""
	match = re.search('initial state: (?P<pots>[\.#]*)', lines[0].strip())
	if match == None:
		print("No initial state, exiting")
		quit()
	else:
		pots = match['pots']

	# now let's get our notes
	notes = {}

	for i in range(1, len(lines)):
		match = re.search('(?P<state>[\.#]{5}) => (?P<outcome>[\.#])', lines[i].strip())
		if match == None:
			continue
		else:
			notes[match['state']] = match['outcome']

	return pots,notes

def getPattern(i, pots):
	pattern = ""
	for location in range(i-2, i+3):
		if location < 0:
			pattern = pattern + "."
		elif location >= len(pots):
			pattern = pattern + "."
		else:
			pattern = pattern + pots[location]
	return pattern


##### START MAIN #####
with open('input') as input:
	pots,notes = parseInput(list(input))

generations = 20
zeroPot = 0

for i in range(generations):
	newPots = ""
	for i in range(-1, len(pots)+1):
		pattern = getPattern(i, pots)
		if pattern in notes:
			if notes[pattern] == "#" and (i < 0 or i == len(pots)):
				# only include ones current if they flower
				newPots = newPots + notes[pattern]
				if i < 0:
					zeroPot = zeroPot + 1
			elif i >= 0 and i < len(pots):
				newPots = newPots + notes[pattern]
		elif i >= 0 and i < len(pots):
			## assume no plant
			newPots = newPots + "."
	pots = newPots

sumPlants = 0
for i in range(len(pots)):
	if pots[i] == "#":
		sumPlants = sumPlants + (i - zeroPot)


print("The answer is " + str(sumPlants))