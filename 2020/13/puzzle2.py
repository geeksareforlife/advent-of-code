import math

def getU(nDiv, n):
	# need to find an integer, u, where nDiv * u = 1 (mod n)
	u = 0
	while True:
		if ((nDiv * u) % n) == 1:
			return u
		else:
			u += 1

with open('input') as input:
	details = list(input)

busIDs = details[1].strip().split(',')

# attempt to do this using CRT: https://www.dave4math.com/mathematics/chinese-remainder-theorem/

crt = []

# first, get the n and a for each bus
offset = 0
for bus in busIDs:
	if bus != 'x':
		crt.append({'n': int(bus), 'a': -1 * offset})
	offset += 1

N = math.prod([x['n'] for x in crt])
print(N)
# now the N divisier and u
for bus in crt:
	bus['nDiv'] = int(N / bus['n'])
	bus['u'] = getU(bus['nDiv'], bus['n'])

	# and the part we are going to use:
	bus['x'] = bus['a'] * bus['nDiv'] * bus['u']

# finally we should be able to calculate...
x = sum([x['x'] for x in crt]) % N

for row in crt:
	print(row)
print(x)