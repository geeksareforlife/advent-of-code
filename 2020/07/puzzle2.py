import re

def processRule(rule):
	(colour, bags) = rule.split(" bags contain ")
	
	contains = {}

	if bags != "no other bags.":
		matches = re.findall('((\d+) ([\w ]*) bags?(\, |\.))', bags)

		for match in matches:
			contains[match[2]] = int(match[1])

	return (colour, contains)

def getBags(colour, bags):
	totalBags = 0

	neededBags = bags[colour]

	if len(neededBags) > 0:
		for neededColour in neededBags:
			totalBags = totalBags + neededBags[neededColour] + (neededBags[neededColour] * getBags(neededColour, bags))
		return totalBags
	else:	
		return 0



with open('input') as input:
	rules = list(input)

rules = [x.strip() for x in rules]

bags = {}

for rule in rules:
	(colour, contains) = processRule(rule)

	bags[colour] = contains

totalBags = getBags('shiny gold', bags)

print("You would need " + str(totalBags) + " bags in your shiny gold bag")