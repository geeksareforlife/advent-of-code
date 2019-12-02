import math

def calculateFuelRequired(mass):
	fuel = 0

	while True:
		required = int(math.floor(mass / 3))
		required = required - 2

		if required > 0:
			fuel = fuel + required
			mass = required
		else:
			return fuel



with open('input') as input:
	modules = list(input)

fuelRequired = 0

for module in modules:
	fuelRequired = fuelRequired + calculateFuelRequired(int(module.strip()))

print fuelRequired