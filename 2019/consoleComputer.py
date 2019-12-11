import sys
sys.path.append('packages')

from intcode.intcode import Intcode

computer = Intcode()

f = open('11/input.matt')
programme = f.read();

computer.loadProgramme(programme)

computer.showOpCodes()

computer.run()