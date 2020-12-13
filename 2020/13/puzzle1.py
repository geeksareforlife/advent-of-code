import math

with open('input') as input:
	details = list(input)

earliest = int(details[0].strip())
busIDs = details[1].strip().split(',')



# find the last time the bus departed
lastDepartures = {}

for bus in busIDs:
	if bus == 'x':
		continue
	else:
		bus = int(bus)
		lastDepartures[bus] = math.floor(earliest / bus) * bus

nextBus = 0
timeUntilDepart = 1000

for busID in lastDepartures:
	nextDepart = (lastDepartures[busID] + busID) - earliest
	if nextDepart < timeUntilDepart:
		nextBus = busID
		timeUntilDepart = nextDepart

print("The answer is " + str(nextBus * timeUntilDepart))