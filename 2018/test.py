import itertools

list = ["item 1", "item 2", "item 3", "item 4"]
list2 = ["Ruth", "Rob", "James", "Andy"]

print("STARTING LOOP 1")

for item in list:
	print(item)

print("FINISHED LOOP 1")
print("STARTING LOOP 2")

for item in list2:
	print(item)
	

print("FINSIHED LOOP 2")
print("STARTING LOOP 3")

for i in range(len(list)): # [0, 1, 2]
	print(list[i])
	print(list2[i])


print("FINSIHED LOOP 3")

count = 0

for item in itertools.cycle(list):
	print(item)
	print(count)
	count += 1 # count = count + 1
	if count > 1000:
		break
