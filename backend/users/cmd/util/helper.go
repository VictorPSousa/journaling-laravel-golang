package util

func CoalesceString(values ...string) string {
	for _, val := range values {
		if len(val) > 0 {
			return val
		}
	}
	return ""
}
