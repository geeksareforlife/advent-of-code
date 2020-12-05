import math

def getId(seat):
	bottomRow = 0
	topRow = 127

	bottomCol = 0
	topCol = 7

	for instruction in seat:
		if bottomRow != topRow:
			mid = bottomRow + math.floor((topRow - bottomRow) / 2)

			if instruction == 'F':
				topRow = mid
			elif instruction == 'B':
				bottomRow = mid + 1
			else:
				print("Error in Rows")
		elif bottomCol != topCol:
			mid = bottomCol + math.floor((topCol - bottomCol) / 2)

			if instruction == 'L':
				topCol = mid
			elif instruction == 'R':
				bottomCol = mid + 1
			else:
				print("Error in Columns")

	return (topRow * 8) + topCol


with open('input') as input:
	seats = list(input)

seats = [x.strip() for x in seats]

ids = set()

for seat in seats:
	ids.add(getId(seat))

sortedSeats = sorted(ids)

lastSeat = 0

for seat in sortedSeats:
	if seat - lastSeat == 2:
		print("My seat is " + str(lastSeat + 1))
	else:
		lastSeat = seat