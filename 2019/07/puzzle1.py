import sys
sys.path.append('../packages')

from intcode.intcode import Intcode
from itertools import permutations

computer = Intcode()

f = open('input')
programme = f.read();


possibleSettings = permutations([0, 1, 2, 3, 4])

maxSignal = 0
maxSettings = ()

for phaseSettings in list(possibleSettings):
	signal = 0

	for phase in phaseSettings:

		computer.loadProgramme(programme)
		computer.addInput(phase)
		computer.addInput(signal)

		computer.setOutputMode("saved")

		computer.run()

		signal = computer.getOutput()

	if signal > maxSignal:
		maxSignal = signal
		maxSettings = phaseSettings

print(maxSignal)
print(maxSettings)