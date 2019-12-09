import sys
sys.path.append('../packages')

from intcode.intcode import Intcode
from itertools import permutations

def computersHalted(computers):
	running = True

	for computer in computers:
		if computer.hasHalted() == False:
			running = False

	return running

f = open('input')
programme = f.read();


possibleSettings = permutations([5, 6, 7, 8, 9])

maxSignal = 0
maxSettings = ()

for phaseSettings in list(possibleSettings):
	lastOutput = 0

	computers = [Intcode(), Intcode(), Intcode(), Intcode(), Intcode()]

	started = [False, False, False, False, False]

	while True:
		for i in range(len(phaseSettings)):
			#print(phaseSettings[i])
			if started[i] == False:
				computers[i].loadProgramme(programme)
				computers[i].addInput(phaseSettings[i])
				computers[i].setOutputMode("saved")
				computers[i].setInputMode("internal")
				computers[i].run()
				#print(i)
				started[i] = True
				#print(started)

			computers[i].addInput(lastOutput)
			
			lastOutput = computers[i].getOutput()

			if computersHalted(computers) == True:
				break

		if computersHalted(computers) == True:
			if lastOutput > maxSignal:
				maxSignal = lastOutput
				maxSettings = phaseSettings
			break

print(maxSignal)
print(maxSettings)