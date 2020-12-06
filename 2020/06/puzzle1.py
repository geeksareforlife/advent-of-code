with open('input') as input:
	people = list(input)

people = [x.strip() for x in people]

groupCounts = []

group = {}

for person in people:
	if person == "":
		# end of group, count and reset
		groupCounts.append(len(sorted(group)))
		group = {}
	else:
		for answer in person:
			group[answer] = group.get(answer, 0) + 1

print("The sum of the counts is " + str(sum(groupCounts)))