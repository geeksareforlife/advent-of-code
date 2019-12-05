import sys
sys.path.append('../packages')

from intcode.intcode import Intcode

computer = Intcode()

f = open('input')
programme = f.read();

def loopPairs(n):
	for i in range(100):
		for j in range(100):
			yield i, j

for i,j in loopPairs(100):
	computer.loadProgramme(programme)

	computer.setNoun(i)
	computer.setVerb(j)

	computer.run()

	if computer.getAddressZero() == 19690720:
		print((i * 100) + j)
		break