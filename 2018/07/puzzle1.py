import re
from string import ascii_uppercase

# for test
#allSteps = "ABCDEF"
# for main
allSteps = ascii_uppercase

def parseInstructions(instructions):
	steps = {key: [] for key in allSteps}

	for instruction in instructions:
		match = re.search('Step (?P<precedent>[A-Z]) must be finished before step (?P<step>[A-Z]) can begin.', instruction.strip())
		if match == None:
			print("Instruction not matched: " + instruction)
		else:
			if match['step'] not in steps:
				print("allSteps not initialised correctly")
			steps[match['step']].append(match['precedent'])

	return steps

def getPotentialSteps(steps):
	potentialSteps = []

	for step,precendents in steps.items():
		if len(precendents) == 0:
			potentialSteps.append(step)

	return potentialSteps

def carryOutStep(completedStep, steps):
	del steps[completedStep]

	for step,precendents in steps.items():
		if completedStep in precendents:
			precendents.remove(completedStep)

	return steps


##### START MAIN #####
with open('input') as input:
	steps = parseInstructions(list(input))

order = ""

while len(order) < len(allSteps):
	potentialSteps = getPotentialSteps(steps)

	if len(potentialSteps) == 1:
		steps = carryOutStep(potentialSteps[0], steps)
		order = order + potentialSteps[0]
	else:
		# assume we can do the last step...
		nextStep = allSteps[len(allSteps)-1]
		for potentialStep in potentialSteps:
			if potentialStep < nextStep:
				nextStep = potentialStep

		steps = carryOutStep(nextStep, steps)
		order = order + nextStep


print("The order of steps is " + order)

