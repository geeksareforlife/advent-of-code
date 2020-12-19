with open('input.tickets') as input:
	tickets = list(input)

#print(tickets)

tickets = [x.strip().split(",") for x in tickets]
tickets = [[int(i) for i in ticket] for ticket in tickets]

rangeMin = 29
rangeMax = 974

invalidValues = []
validTickets = []

for ticket in tickets:
	valid = True
	for value in ticket:
		if value < rangeMin or value > rangeMax:
			invalidValues.append(value)
			valid = False
	if valid:
		validTickets.append(ticket)

f = open('input.validtickets', 'w')
for ticket in validTickets:
	f.write(",".join(str(x) for x in ticket) + "\n")
f.close()


print("The ticket scanning error rate is " + str(sum(invalidValues)))


