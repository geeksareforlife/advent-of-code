freq = 0

with open('input') as input:
	changes = list(input)

for change in changes:
	freq = freq + int(change.strip())

print("The resulting frequency is " + str(freq))
