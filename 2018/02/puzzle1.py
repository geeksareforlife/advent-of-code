
def getLetterCount(boxIds, target):
	boxCount = 0
	for boxId in boxIds:
		letterMap = getLetterMap(boxId.strip())

		for char, charCount in letterMap.items():
			if charCount == target:
				boxCount += 1
				break

	return boxCount

def getLetterMap(boxId):
	letterMap = {}
	for char in boxId:
		if char not in letterMap:
			letterMap[char] = 0
		letterMap[char] += 1
	return letterMap


with open('input') as input:
	boxIds = list(input)

withTwo = getLetterCount(boxIds, 2)
withThree = getLetterCount(boxIds, 3)

checksum = withTwo * withThree

print(str(withTwo) + " boxes have two duplicated letters")
print(str(withThree) + " boxes have three duplicated letters")
print("The checksum is " + str(checksum))