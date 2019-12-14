import sys
sys.path.append('packages')

from intcode.intcode import Intcode

computer = Intcode()

f = open('13/input')
programme = f.read();

computer.loadProgramme(programme)

computer.showOpCodes()

computer.run()