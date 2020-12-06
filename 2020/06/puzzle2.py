with open('input') as input:
	people = list(input)

people = [x.strip() for x in people]

groupCounts = []

group = {}
groupNum = 0

for person in people:
	if person == "":
		# end of group, count and reset
		groupCounts.append(len([k for k,v in group.items() if v == groupNum]))
		group = {}
		groupNum = 0
	else:
		groupNum += 1
		for answer in person:
			group[answer] = group.get(answer, 0) + 1

print("The sum of the counts is " + str(sum(groupCounts)))