import sys
sys.path.append('../packages')

from intcode.intcode import Intcode

computer = Intcode()

f = open('input')
programme = f.read();

# even though it hasn;t changed, add the input here so we can time the computer on the console :)
computer.loadProgramme(programme)
computer.setInputMode("internal")
computer.addInput(2)

computer.run()