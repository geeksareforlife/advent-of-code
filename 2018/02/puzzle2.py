
def compareBoxIds(boxA, boxB):
	same = 0
	for i in range(len(boxA)):
		if boxA[i] == boxB[i]:
			same += 1

	return same




with open('input') as input:
	boxIds = list(input)

numBoxes = len(boxIds)
boxIdLength = len(boxIds[0].strip())

for i in range(numBoxes):
	thisBox = boxIds.pop().strip()

	for boxId in boxIds:
		sameChars = compareBoxIds(thisBox, boxId.strip())
		if boxIdLength - sameChars == 1:
			check = ""
			for i in range(len(thisBox)):
				if thisBox[i] == boxId[i]:
					check += thisBox[i]
			print(check)