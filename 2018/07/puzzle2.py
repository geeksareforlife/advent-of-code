import re
from string import ascii_uppercase

# for test
# allSteps = "ABCDEF"
# numWorkers = 2
# baseTime = 0
# for main
allSteps = ascii_uppercase
numWorkers = 5
baseTime = 60




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
currentTime = 0
currentTasks = []
workers = []

while len(order) < len(allSteps):
	potentialSteps = getPotentialSteps(steps)
	potentialSteps.sort()

	for potentialStep in potentialSteps:
		if potentialStep in currentTasks:
			continue
		if len(workers) < numWorkers:
			timeRequired = baseTime + (ascii_uppercase.index(potentialStep) + 1)

			workers.append({'step': potentialStep, 'required': timeRequired, 'elapsed': 0})
			currentTasks.append(potentialStep)

	# now, add one to the time and see if any workers have completed
	currentTime = currentTime + 1

	newWorkers = []
	for i in range(len(workers)):
		workers[i]['elapsed'] = workers[i]['elapsed'] + 1
		if workers[i]['elapsed'] == workers[i]['required']:
			steps = carryOutStep(workers[i]['step'], steps)
			order = order + workers[i]['step']
			currentTasks.remove(workers[i]['step'])
		else:
			newWorkers.append(workers[i])

	workers = newWorkers


print("The order of steps is " + order)
print("The work took " + str(currentTime) + " seconds")

