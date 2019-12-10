import math

def getAngleToTarget(asteroid, target):
	diffX = target[0] - asteroid[0]
	diffY = target[1] - asteroid[1]

	angle = math.degrees(math.atan2(diffY, diffX))

	# normalise angle to that up is 0
	if angle >= -90:
		angle = angle + 90
	elif angle < -90:
		angle = 360 + angle + 90
	
	return angle
	

def getDistanceToTarget(asteroid, target):
	diffX = abs(target[0] - asteroid[0])
	diffY = abs(target[1] - asteroid[1])

	return math.sqrt(diffX**2 + diffY**2)
	

with open('input') as input:
	mapRows = list(input)

asteroids = {}

coordX = 0
coordY = 0
for row in mapRows:
	row = row.strip()

	coordX = 0
	for location in row:
		if location == "#":
			asteroids[(coordX, coordY)] = {}
		coordX = coordX + 1

	coordY = coordY + 1

# work out distance and angle to each other asteroid
# if angles are the same, we only care about the closest

for asteroid in asteroids:

	for target in asteroids:
		if asteroid != target:
			angle = getAngleToTarget(asteroid, target)
			distance = getDistanceToTarget(asteroid, target)

			if angle not in asteroids[asteroid]:
				asteroids[asteroid][angle] = []

			asteroids[asteroid][angle].append((distance, target))


# which is the best?
bestLocation = (-1, -1)
detectedAsteroids = 0

for asteroid in asteroids:
	if len(asteroids[asteroid]) > detectedAsteroids:
		bestLocation = asteroid
		detectedAsteroids = len(asteroids[asteroid])

print("The best location is " + str(bestLocation) + " and it can detect " + str(detectedAsteroids) + " asteroids")

while True:
	asteroid = 0
	for angle in sorted(asteroids[bestLocation]):
		asteroids[bestLocation][angle].sort(key=lambda tup: tup[0])
		
		if len(asteroids[bestLocation][angle]) > 0:
			destroyed = asteroids[bestLocation][angle].pop()
			asteroid = asteroid + 1
			if asteroid == 200:
				print("The 200th asteroid to be destroyed was at " + str(destroyed[1]))
				index = (destroyed[1][0] * 100) + destroyed[1][1]
				print("The asteroid index is " + str(index))
				exit()

