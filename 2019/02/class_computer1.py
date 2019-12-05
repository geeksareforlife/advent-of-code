import sys
sys.path.append('../packages')

from intcode.intcode import Intcode

computer = Intcode()

f = open('input.test')
programme = f.read();

computer.loadProgramme(programme)

# computer.setNoun(12)
# computer.setVerb(2)

computer.run()

print(computer.getAddressZero())