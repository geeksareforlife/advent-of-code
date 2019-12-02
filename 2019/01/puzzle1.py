import math

def calculateFuelRequired(mass):
	fuel = int(math.floor(mass / 3))

	fuel = fuel - 2

	return fuel



with open('input') as input:
	modules = list(input)

fuelRequired = 0

for module in modules:
	fuelRequired = fuelRequired + calculateFuelRequired(int(module.strip()))

print fuelRequired