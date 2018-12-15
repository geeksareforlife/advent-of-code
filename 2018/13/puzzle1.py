from copy import deepcopy

def parseTrack(lines):
	track = []
	carts = []

	for y in range(len(lines)):
		trackLine = []
		for x in range(len(lines[y])):
			char = lines[y][x]
			if char == ">":
				trackLine.append("-")
				carts.append(createCart(x, y, "right"))
			elif char == "<":
				trackLine.append("-")
				carts.append(createCart(x, y, "left"))
			elif char == "^":
				trackLine.append("|")
				carts.append(createCart(x, y, "up"))
			elif char == "v":
				trackLine.append("|")
				carts.append(createCart(x, y, "down"))
			elif char == "\n":
				# skip
				continue
			else:
				trackLine.append(char)
		track.append(trackLine)

	return track, carts

def createCart(x, y, direction):
	cart = {
		'x': x,
		'y': y,
		'direction': direction,
		'turn': 0
	}

	return cart

def moveCart(cart, track):
	# right turns are +1, left turns are -1
	directions = ["up", "right", "down", "left"]
	turns = [-1, 0, +1]

	newX = cart['x']
	newY = cart['y']

	if cart['direction'] == "up":
		newY = newY - 1
	elif cart['direction'] == "down":
		newY = newY + 1
	elif cart['direction'] == "right":
		newX = newX + 1
	elif cart['direction'] == "left":
		newX = newX - 1

	if track[newY][newX] == "+":
		# need to change direction based on turn count
		# get current location
		current = directions.index(cart['direction'])
		cart['direction'] = directions[(current + turns[(cart['turn'] % 3)]) % 4]
		cart['turn'] = cart['turn'] + 1
	elif track[newY][newX] == "/":
		# need to change direction
		if cart['direction'] == "left":
			cart['direction'] = "down"
		elif cart['direction'] == "up":
			cart['direction'] = "right"
		elif cart['direction'] == "right":
			cart['direction'] = "up"
		elif cart['direction'] == "down":
			cart['direction'] = "left"
	elif track[newY][newX] == "\\":
		# need to change direction
		if cart['direction'] == "left":
			cart['direction'] = "up"
		elif cart['direction'] == "up":
			cart['direction'] = "left"
		elif cart['direction'] == "right":
			cart['direction'] = "down"
		elif cart['direction'] == "down":
			cart['direction'] = "right"

	cart['x'] = newX
	cart['y'] = newY

def checkCarts(carts):
	locationsSeen = []
	crashSite = {}
	crashed = False

	for cart in carts:
		location = str(cart['x']) + "," + str(cart['y'])
		if location in locationsSeen:
			crashed = True
			crashSite = {'x': cart['x'], 'y': cart['y']}
		else:
			locationsSeen.append(location)

	return crashed, crashSite

def printTrack(track, carts):
	displayTrack = deepcopy(track)

	directions = {
		"up": "^",
		"down": "v",
		"right": ">",
		"left": "<"
	}

	for cart in carts:
		displayTrack[cart['y']][cart['x']] = directions[cart['direction']]

	for y in range(len(displayTrack)):
		line = ""
		for x in range(len(displayTrack[y])):
			line = line + displayTrack[y][x]
		print(line)
	print("")


##### START MAIN #####
with open('input') as input:
	track, carts = parseTrack(list(input))

crashed = False
crashSite = {}

#print(carts)
while crashed == False:
	#printTrack(track, carts)
	carts = sorted(carts, key = lambda k: (k['y'], k['x']))
	for cart in carts:
		moveCart(cart, track)

	crashed,crashSite = checkCarts(carts)

	

print("Crashed at " + str(crashSite['x']) + "," + str(crashSite['y']))
