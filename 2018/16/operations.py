
### Addition ###

# addr (add register) stores into register C the result of adding register A and register B.
def addr(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] + localRegisters[B]

	return localRegisters

# addi (add immediate) stores into register C the result of adding register A and value B.
def addi(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] + B

	return localRegisters

### Multiplication ###

# mulr (multiply register) stores into register C the result of multiplying register A and register B.
def mulr(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] * localRegisters[B]

	return localRegisters

# muli (multiply immediate) stores into register C the result of multiplying register A and value B.
def muli(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] * B

	return localRegisters

### Bitwise AND ###

# banr (bitwise AND register) stores into register C the result of the bitwise AND of register A and register B.
def banr(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] & localRegisters[B]

	return localRegisters

# bani (bitwise AND immediate) stores into register C the result of the bitwise AND of register A and value B.
def bani(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] & B

	return localRegisters

### Bitwise OR ###

# borr (bitwise OR register) stores into register C the result of the bitwise OR of register A and register B.
def borr(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] | localRegisters[B]

	return localRegisters

# bori (bitwise OR immediate) stores into register C the result of the bitwise OR of register A and value B.
def bori(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A] | B

	return localRegisters

### Assignment ###

# setr (set register) copies the contents of register A into register C. (Input B is ignored.)
def setr(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = localRegisters[A]

	return localRegisters

# seti (set immediate) stores value A into register C. (Input B is ignored.)
def seti(registers, A, B, C):
	localRegisters = registers[:]

	localRegisters[C] = A

	return localRegisters

### Greater-than testing ###

# gtir (greater-than immediate/register) sets register C to 1 if value A is greater than register B. Otherwise, register C is set to 0.
def gtir(registers, A, B, C):
	localRegisters = registers[:]

	if A > localRegisters[B]:
		localRegisters[C] = 1
	else:
		localRegisters[C] = 0

	return localRegisters

# gtri (greater-than register/immediate) sets register C to 1 if register A is greater than value B. Otherwise, register C is set to 0.
def gtri(registers, A, B, C):
	localRegisters = registers[:]

	if localRegisters[A] > B:
		localRegisters[C] = 1
	else:
		localRegisters[C] = 0

	return localRegisters

# gtrr (greater-than register/register) sets register C to 1 if register A is greater than register B. Otherwise, register C is set to 0.
def gtrr(registers, A, B, C):
	localRegisters = registers[:]

	if localRegisters[A] > localRegisters[B]:
		localRegisters[C] = 1
	else:
		localRegisters[C] = 0

	return localRegisters

### Equality testing ###

# eqir (equal immediate/register) sets register C to 1 if value A is equal to register B. Otherwise, register C is set to 0.
def eqir(registers, A, B, C):
	localRegisters = registers[:]

	if A == localRegisters[B]:
		localRegisters[C] = 1
	else:
		localRegisters[C] = 0

	return localRegisters

# eqri (equal register/immediate) sets register C to 1 if register A is equal to value B. Otherwise, register C is set to 0.
def eqri(registers, A, B, C):
	localRegisters = registers[:]

	if localRegisters[A] == B:
		localRegisters[C] = 1
	else:
		localRegisters[C] = 0

	return localRegisters

# eqrr (equal register/register) sets register C to 1 if register A is equal to register B. Otherwise, register C is set to 0.
def eqrr(registers, A, B, C):
	localRegisters = registers[:]

	if localRegisters[A] == localRegisters[B]:
		localRegisters[C] = 1
	else:
		localRegisters[C] = 0

	return localRegisters


# List of all operations
operations = [addr, addi, mulr, muli, banr, bani, borr, bori, setr, seti, gtir, gtri, gtrr, eqir, eqri, eqrr]