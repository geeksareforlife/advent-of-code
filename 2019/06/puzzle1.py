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

with open('input') as input:
	orbits = list(input)

planets = set()
directOrbits = {}

for orbit in orbits:
	match = re.search('(.*)\)(.*)', orbit.strip())

	if match != None:
		planets.add(match[1])
		planets.add(match[2])

		directOrbits[match[2]] = match[1]

# start with direct orbits
totalOrbits = len(directOrbits)

indirectOrbits = {}

for planet in planets:
	if planet == "COM":
		continue

	orbits = getIndirects(planet, directOrbits)

	totalOrbits = totalOrbits + len(orbits)

	indirectOrbits[planet] = orbits

print(totalOrbits)
