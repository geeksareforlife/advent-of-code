import re

def makeClaim(fabric, claimId, startX, startY, lengthX, lengthY):

	fabric = extendFabric(fabric, startX, startY, lengthX, lengthY)

	for x in range(startX, startX + lengthX):
		for y in range(startY, startY + lengthY):
			fabric[x][y].append(claimId)

	return fabric

def extendFabric(fabric,startX, startY, lengthX, lengthY):

	while len(fabric) < startX + lengthX:
		fabric.append([])

	for column in range(startX, startX + lengthX):
		while len(fabric[column]) < startY + lengthY:
			fabric[column].append([])

	return fabric

def printFabric(fabric):
	lines = []
	numLines = 0
	for column in fabric:
		if len(column) > numLines:
			numLines = len(column)

	for line in range(numLines):
		lines.append("")

	for column in fabric:
		for row in range(numLines):
			if len(column) <= row:
				lines[row] = lines[row] + "."
			elif len(column[row]) == 0:
				lines[row] = lines[row] + "."
			else:
				lines[row] = lines[row] + str(len(column[row]))

	for line in lines:
		print(line)


# this will be a multi-dimensional array
# The first two dimensions will be columns and rows.
# Each cell will contain an array of the IDs that are claiming that square inch
fabric = []

with open('input') as input:
	claims = list(input)

for claim in claims:
	match = re.search('(#\d+) @ (\d+),(\d+): (\d+)x(\d+)', claim.strip())
	if (match == None):
		print("Claim not matched: " + claim.strip())
	else:
		claimId = match[1]
		startX = int(match[2])
		startY = int(match[3])
		lengthX = int(match[4])
		lengthY = int(match[5])

		fabric = makeClaim(fabric, claimId, startX, startY, lengthX, lengthY)

# loop over the fabric and make a list of claims that do overlap
overlapClaims = []
for column in fabric:
	for row in column:
		if len(row) > 1:
			for claim in row:
				claimId = int(claim.replace('#',''))
				if claimId not in overlapClaims:
					overlapClaims.append(claimId)

for claimId in range(1, len(claims) + 1):
	if claimId not in overlapClaims:
		print("Claim " + str(claimId) + " does not overlap")
