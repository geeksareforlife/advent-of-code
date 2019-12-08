inputFile = open('input')
imageData = inputFile.read().strip()

imageHeight = 25
imageWidth = 6

# First, we are going to build our array of layers
image = []
currentRow = 0
layer = []

for number in imageData:
	number = int(number)
	if len(layer) - 1 < currentRow:
		layer.append([])

	layer[currentRow].append(number)

	if len(layer[currentRow]) == imageWidth:
		currentRow = currentRow + 1

		if len(layer) == imageHeight:
			image.append(layer)
			currentRow = 0
			layer = []

# Now, loop over the image and build an index of the layers
layerIndex = []

for layer in image:
	index = {}

	for row in layer:
		for number in row:
			if number not in index:
				index[number] = 0

			index[number] = index[number] + 1

	layerIndex.append(index)

# Finally, find the layer with the least zeros

leastZeros = 1000
layer = False

for layerNum in range(len(layerIndex)):
	index = layerIndex[layerNum]
	if 0 in index:
		if index[0] < leastZeros:
			layer = layerNum
			leastZeros = index[0]

checksum = layerIndex[layer][1] * layerIndex[layer][2]

print("Layer " + str(layer + 1) + " has the least zeros")
print("The checksum is " + str(checksum))


