import re

def processRule(rule):
	(colour, bags) = rule.split(" bags contain ")
	
	contains = {}

	if bags != "no other bags.":
		matches = re.findall('((\d+) ([\w ]*) bags?(\, |\.))', bags)

		for match in matches:
			contains[match[2]] = match[1]

	return (colour, contains)

def findBags(colour, bags):
	colours = []

	for bag in bags:
		if colour in list(bags[bag]):
			colours.append(bag)

	return colours

with open('input') as input:
	rules = list(input)

rules = [x.strip() for x in rules]

bags = {}

for rule in rules:
	(colour, contains) = processRule(rule)

	bags[colour] = contains

allowedBags = set()
searchColours = ['shiny gold']

while len(searchColours) > 0:
	colour = searchColours.pop()

	colours = findBags(colour, bags)

	if len(colours) > 0:
		searchColours.extend(colours)
		for newColour in colours:
			allowedBags.add(newColour)

print("You could use 1 of " + str(len(allowedBags)) + " bags")