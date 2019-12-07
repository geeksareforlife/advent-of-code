import re

def getIndirects(planet, directOrbits):

	direct = directOrbits[planet]

	if direct in directOrbits:
		indirect = directOrbits[direct]
		indirects = [indirect]

		extras = getIndirects(direct, directOrbits)
		if len(extras) > 0:
			indirects.extend(extras)	
		
		return indirects
	else:
		return []

def getDistance(origin, end, orbits):
	distance = 0

	for planet in orbits[origin]:
		if planet == end:
			return distance
		else:
			distance = distance + 1

with open('input') as input:
	orbits = list(input)

planets = set()
parentPlanets = {}
directOrbits = {}

for orbit in orbits:
	match = re.search('(.*)\)(.*)', orbit.strip())

	if match != None:
		planets.add(match[1])
		planets.add(match[2])

		parentPlanets[match[2]] = [match[1]]
		directOrbits[match[2]] = match[1]

indirectOrbits = {}

for planet in planets:
	if planet == "COM":
		continue

	orbits = getIndirects(planet, directOrbits)

	parentPlanets[planet].extend(orbits)

# find the common parents of both SAN and YOU

commonParents = []

for parent in parentPlanets['YOU']:
	if parent in parentPlanets['SAN']:
		commonParents.append(parent)

# now, find out how far the transfer would be via each parent
# (I think the shortest would always be the first one, but better safe than sorry)

lowest = 1000

for parent in commonParents:
	transfer = getDistance('YOU', parent, parentPlanets) + getDistance('SAN', parent, parentPlanets)

	if transfer < lowest:
		lowest = transfer

print("Lowest number of transfers is " + str(lowest))