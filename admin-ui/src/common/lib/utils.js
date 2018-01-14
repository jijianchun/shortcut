export default {
	toDouble (n) {
		return parseInt(n) > 9 ? n : '0' + n
	}
}