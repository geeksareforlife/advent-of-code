with open('input') as input:
	numbers = list(input)

numbers = [int(x) for x in numbers]

target = 32321523
#target = 127
end = len(numbers)

foundNumbers = []

for i in range(0, end):
	test = numbers[i]
	for j in range(i+1, end):
		test = test + numbers[j]
		if test == target:
			# yay!
			foundNumbers = numbers[i:j+1]
		elif test > target:
			break

if len(foundNumbers) > 0:
	weakness = min(foundNumbers) + max(foundNumbers)
	print("The weakness is " + str(weakness))
else:
	print("Not found!")