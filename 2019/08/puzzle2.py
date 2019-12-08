import sys
from termcolor import colored, cprint

inputFile = open('input')
imageData = inputFile.read().strip()

imageHeight = 6
imageWidth = 25

# First, we are going to build our array of layers
layers = []
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
			layers.append(layer)
			currentRow = 0
			layer = []

colours = ['black', 'white', 'transparent']
transparent = 2

# now we are going to build oour real image
image = []
numLayers = len(layers)

for row in range(imageHeight):
	image.append([])
	for column in range(imageWidth):
		image[row].append([])
		for layer in range(numLayers):
			# I want the first non-transparent pixel
			if layers[layer][row][column] != transparent:
				image[row][column] = colours[layers[layer][row][column]]
				break

# finally, display the image

for row in image:
	for pixel in row:
		if pixel == "black":
			cprint(" ", end='')
		else:
			cprint(" ", 'red', 'on_'+pixel, end='')

	cprint(" ")