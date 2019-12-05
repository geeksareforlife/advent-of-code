import sys
sys.path.append('../packages')

from intcode.intcode import Intcode

computer = Intcode()

f = open('input')
programme = f.read();

computer.loadProgramme(programme)

computer.run()