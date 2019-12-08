import sys
sys.path.append('../packages')

from intcode.intcode import Intcode
from itertools import permutations

def computersRunning(computers):
	running = False

	for computer in computers:
		if computer.isRunning():
			running = True

	return running

f = open('input')
programme = f.read();


possibleSettings = permutations([0, 1, 2, 3, 4])

maxSignal = 0
maxSettings = ()

for phaseSettings in list(possibleSettings):
	signals = [0,False,False,False,False]

	computers = [Intcode(), Intcode(), Intcode(), Intcode(), Intcode()]

	started = [False, False, False, False, False]

	while True:
		for i in range(len(phaseSettings)):
			if started[i] == False:
				computers[i].loadProgramme(programme)
				computers[i].addInput(phaseSettings[i])
				computers[i].setOutputMode("saved")
				computers[i].setInputMode("internal")
				computers[i].run()
				print(i)
				started[i] = True
				print(started)

			if signals[i] != False:
				computers[i].addInput(signals[i])
				signals[i] = False

			outputSignal = computers[i].getOutput()

			if outputSignal != False:
				nextComputer = i + 1
				if nextComputer == 5:
					nextComputer = 0
				signals[nextComputer] = outputSignal

			print(signals)

			if computersRunning(computers) == False:
				break


# 		signal = computer.getOutput()

# 	if signal > maxSignal:
# 		maxSignal = signal
# 		maxSettings = phaseSettings

# print(maxSignal)
# print(maxSettings)