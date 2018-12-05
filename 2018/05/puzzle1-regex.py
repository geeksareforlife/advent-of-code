import re

inputFile = open('input')
polymer = inputFile.read()

newLength = len(polymer)
oldLength = len(polymer) + 1

while newLength < oldLength:
	oldLength = newLength
	polymer = re.sub('(?i:(.)\\1)(?<=[a-z][A-Z]|[A-Z][a-z])', '', polymer)
	newLength = len(polymer)

print("The final polymer has " + str(len(polymer)) + " units")